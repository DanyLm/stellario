import { getStars } from '@/services/starApi'

export default defineEventHandler(async (event) => {
  const res: any = await getStars()
  return res
})
