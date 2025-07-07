'use client'
import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import styles from '@/styles/Dashboard.module.scss';

export default function Dashboard() {
  const [name, setName] = useState('');
  const router = useRouter();

  useEffect(() => {
    const raw = localStorage.getItem('user');
    if (!raw) {
      router.push('/auth');
      return;
    }
    const user = JSON.parse(raw);
    setName(user.name || 'کاربر');
  }, []);

  return (
    <div className={styles.container}>
      <h1>سلام {name} عزیز! 👋</h1>
      <p>خوش اومدی به داشبوردت</p>
    </div>
  );
}
