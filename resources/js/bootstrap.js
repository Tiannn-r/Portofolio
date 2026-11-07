import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Automatically inject Bearer token from localStorage
const token = localStorage.getItem('admin_token');
if (token) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Global Axios Response Interceptor for handling 401
window.axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401 && window.location.pathname.startsWith('/admin')) {
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
            delete window.axios.defaults.headers.common['Authorization'];
            if (window.location.pathname !== '/admin/login') {
                window.location.href = '/admin/login';
            }
        }
        return Promise.reject(error);
    }
);
