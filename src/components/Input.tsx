'use client'
import styles from '@/styles/Input.module.scss';

interface Props {
  value: string;
  onChange: (value: string) => void;
  label: string;
  placeholder: string;
}

export default function Input({ value, onChange, label, placeholder }: Props) {
  return (
    <div className={styles.inputWrapper}>
      <label>{label}</label>
      <input
        type="text"
        value={value}
        placeholder={placeholder}
        onChange={(e) => onChange(e.target.value)}
      />
    </div>
  );
}

