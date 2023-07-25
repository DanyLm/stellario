import axios from './axios'

/**
 * getStars
 *
 * @returns
 */
export const getStars = async () => {
  try {
    const response = await axios.get(`/stars`)
    return response.status === 200 ? response.data : []
  } catch (err: any) {
    throw err.message
  }
}
