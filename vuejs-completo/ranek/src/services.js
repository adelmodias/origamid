//   fetch("http://localhost:3000/products")
//     .then(response => response.json())
//     .then(response => (this.products = response));

import axios from "axios";

const axiosInstance = axios.create({
    baseURL: "http://localhost:3000"
})

export const api = {
    get(endpoint) {
        return axiosInstance.get(endpoint);
    },
    post(endpoint, body) {
        return axiosInstance.post(endpoint, body);
    }
};