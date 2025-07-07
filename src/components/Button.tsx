'use client'
import styles from '@/styles/Button.module.scss';

interface Props {
  onClick: () => void;
  children: React.ReactNode;
  disabled?: boolean;
}

export default function Button({ onClick, children, disabled = false }: Props) {
  return (
    <button className={styles.btn} onClick={onClick} disabled={disabled}>
      {children}
    </button>
  );
}
