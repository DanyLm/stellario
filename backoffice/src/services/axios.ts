import axios from 'axios'

const BASE_URL: string = 'http://localhost:8000/api/v1'

export default axios.create({
  baseURL: BASE_URL
})
