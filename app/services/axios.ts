import axios from 'axios'

// const config: any = useRuntimeConfig()
// const BASE_URL: string = config.public.apiBase
const BASE_URL: string = "http://localhost:8000/api/v1"

export default axios.create({
  baseURL: BASE_URL
})
