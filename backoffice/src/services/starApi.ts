import axios from './axios'

/**
 *
 * @param input
 * @param controller AbortController
 * @returns
 */
export const getStars = async (input: string, controller: AbortController) => {
  try {
    let params: string = ''
    if (input.trim()) {
      params = `?search=${input}`
    }

    const response = await axios.get(`/stars${params}`, {
      signal: controller.signal
    })
    return response.status === 200 ? response.data : []
  } catch (err: any) {
    throw err.message
  }
}
