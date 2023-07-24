import { useToast } from 'vue-toast-notification'

const $toast = useToast()

/**
 *
 * @param message
 * @param type
 * @returns
 */
export const toast = (message: string, type: string = 'success') =>
  $toast.open({
    message,
    position: 'top-right',
    type,
    duration: 5000
  })
