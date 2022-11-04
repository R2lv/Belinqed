import axios from 'axios';
let api = axios.create({
	baseURL: "/data"
});
export default api;