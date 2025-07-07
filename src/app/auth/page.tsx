'use client'
import Input from '@/components/Input';
import Button from '@/components/Button';
import styles from '@/styles/Auth.module.scss';
import { useRouter } from 'next/navigation';
import { isValidPhone } from '@/utils/validatePhone';
import { useState } from 'react';

export default function AuthPage() {
  const [phone, setPhone] = useState('');
  const [error, setError] = useState('');
  const router = useRouter();

  const handleLogin = async () => {
    if (!isValidPhone(phone)) {
      setError('شماره موبایل معتبر نیست');
      return;
    }
    try {
      const res = await fetch('https://randomuser.me/api/');
      const data = await res.json();
      const user = data.results[0];
      localStorage.setItem('user', JSON.stringify({ phone, name: user.name.first }));
      router.push('/dashboard');
    } catch (e) {
      setError('خطا در ورود');
    }
  };

  return (
    <div className={styles.container}>
      <h2>ورود به سیستم</h2>
      <Input
        value={phone}
        onChange={setPhone}
        label="شماره موبایل"
        placeholder="مثلاً 09121234567"
      />
      {error && <p className={styles.error}>{error}</p>}
      <Button onClick={handleLogin}>ورود</Button>
    </div>
  );
}
