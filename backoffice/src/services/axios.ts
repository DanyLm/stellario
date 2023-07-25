import axios from 'axios'

const BASE_URL: string = import.meta.env.VITE_API_URL;

export default axios.create({
  baseURL: BASE_URL
})
