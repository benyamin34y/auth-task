export function isValidPhone(phone: string): boolean {
  const regex = /^09\d{9}$/;
  return regex.test(phone);
}
