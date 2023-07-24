/**
 *
 * @param str
 * @returns
 */
export const splitName = (str: string): { first_name: string; last_name: string } => {
  const splited: string[] = str.split(' ')
  const first_name: string = splited.shift() || ''
  const last_name: string = splited.join(' ')

  return {
    first_name,
    last_name
  }
}
