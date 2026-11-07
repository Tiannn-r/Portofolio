import { ref } from 'vue';
import axios from 'axios';
import { useToast } from './useToast';

/**
 * Reusable Composable for Admin CRUD operations
 * Adheres to vercel-composition-pattern & ui-ux-pro-max
 */
export function useAdminCrud({ endpoint, entityName = 'Item', defaultForm = () => ({}) }) {
  const items = ref([]);
  const loading = ref(false);
  const isSaving = ref(false);
  const isDeleting = ref(false);
  const isModalOpen = ref(false);
  const editingItem = ref(null);
  const formData = ref(defaultForm());
  const error = ref(null);

  const { success, error: toastError } = useToast();

  const getHeaders = (isMultipart = false) => {
    const token = localStorage.getItem('admin_token');
    return {
      Authorization: `Bearer ${token}`,
      'Content-Type': isMultipart ? 'multipart/form-data' : 'application/json',
      Accept: 'application/json',
    };
  };

  const fetchItems = async () => {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get(endpoint, {
        headers: getHeaders(),
      });
      if (response.data && response.data.success) {
        items.value = response.data.data;
      }
    } catch (err) {
      error.value = err.response?.data?.message || err.message;
      toastError(`Gagal memuat ${entityName}: ${error.value}`);
    } finally {
      loading.value = false;
    }
  };

  const openCreateModal = (customDefaults = null) => {
    editingItem.value = null;
    formData.value = customDefaults ? { ...customDefaults } : defaultForm();
    isModalOpen.value = true;
  };

  const openEditModal = (item) => {
    editingItem.value = item;
    formData.value = JSON.parse(JSON.stringify(item));
    isModalOpen.value = true;
  };

  const closeModal = () => {
    isModalOpen.value = false;
    editingItem.value = null;
    formData.value = defaultForm();
  };

  const saveItem = async (payloadOverride = null, isMultipart = false) => {
    isSaving.value = true;
    try {
      const payload = payloadOverride || formData.value;
      const isEdit = !!editingItem.value;
      const url = isEdit ? `${endpoint}/${editingItem.value.id}` : endpoint;

      let response;
      if (isMultipart && isEdit) {
        // For Laravel PUT with multipart files, often sent with _method=PUT via POST
        if (payload instanceof FormData) {
          payload.append('_method', 'PUT');
        }
        response = await axios.post(url, payload, { headers: getHeaders(true) });
      } else if (isEdit) {
        response = await axios.put(url, payload, { headers: getHeaders(false) });
      } else {
        response = await axios.post(url, payload, { headers: getHeaders(isMultipart) });
      }

      if (response.data && response.data.success) {
        success(response.data.message || `${entityName} berhasil disimpan`);
        closeModal();
        await fetchItems();
        return { success: true, data: response.data.data };
      }
      return { success: false };
    } catch (err) {
      const msg = err.response?.data?.message || `Gagal menyimpan ${entityName}`;
      toastError(msg);
      return { success: false, error: msg };
    } finally {
      isSaving.value = false;
    }
  };

  const deleteItem = async (id, confirmMessage = `Apakah Anda yakin ingin menghapus ${entityName} ini?`) => {
    if (!confirm(confirmMessage)) return false;

    isDeleting.value = true;
    try {
      const response = await axios.delete(`${endpoint}/${id}`, {
        headers: getHeaders(),
      });
      if (response.data && response.data.success) {
        success(response.data.message || `${entityName} berhasil dihapus`);
        items.value = items.value.filter(item => item.id !== id);
        return true;
      }
      return false;
    } catch (err) {
      const msg = err.response?.data?.message || `Gagal menghapus ${entityName}`;
      toastError(msg);
      return false;
    } finally {
      isDeleting.value = false;
    }
  };

  return {
    items,
    loading,
    isSaving,
    isDeleting,
    isModalOpen,
    editingItem,
    formData,
    error,
    fetchItems,
    openCreateModal,
    openEditModal,
    closeModal,
    saveItem,
    deleteItem,
  };
}

