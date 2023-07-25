import axios from 'axios'

const config: any = useRuntimeConfig()
const BASE_URL: string = config.public.apiBase

export default axios.create({
  baseURL: BASE_URL
})
