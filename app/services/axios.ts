import axios from 'axios'

const BASE_URL = (): string => {
  const config: any = useRuntimeConfig()
  return config.public.apiBase
}

export default axios.create({
  baseURL: BASE_URL()
})
