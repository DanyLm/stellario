import axios from './axios'
import type { StarInterface } from '@/models'

/**
 * getStars
 *
 * @param input
 * @param controller AbortController
 * @returns
 */
export const getStars = async (input: string = '', controller: AbortController | null = null) => {
  try {
    let params: string = ''
    if (input.trim()) {
      params = `?search=${input}`
    }
    const config = controller
      ? {
          signal: controller.signal
        }
      : {}

    const response = await axios.get(`/stars${params}`, { ...config })
    return response.status === 200 ? response.data : []
  } catch (err: any) {
    throw err.message
  }
}

/**
 * editStar
 *
 * @param star StarInterface
 * @returns
 */
export const editStar = async (star: StarInterface) => {
  try {
    const response = await axios.put(`/stars/${star.id}`, { ...star })
    return response.status === 200 ? response.data : {}
  } catch (err: any) {
    throw { ...err }
  }
}

/**
 * deleteStar
 *
 * @param star StarInterface
 * @returns
 */
export const deleteStar = async (star: StarInterface) => {
  try {
    const response = await axios.delete(`/stars/${star.id}`)
    return response.status === 200 ? response.data : {}
  } catch (err: any) {
    throw { ...err }
  }
}

/**
 * createStar
 *
 * @param star StarInterface
 * @returns
 */
export const createStar = async (star: StarInterface) => {
  try {
    const response = await axios.post(`/stars`, { ...star })
    return response.status === 201 ? response.data : {}
  } catch (err: any) {
    throw { ...err }
  }
}

/**
 * editFace
 *
 * @param star
 * @param file
 * @returns
 */
export const editFace = async (star: StarInterface, file: File) => {
  try {
    const formData = new FormData()
    formData.append('image', file)

    const response = await axios.post(`/stars/${star.id}/face`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    return response.status === 200 ? response.data : {}
  } catch (err: any) {
    throw { ...err }
  }
}
