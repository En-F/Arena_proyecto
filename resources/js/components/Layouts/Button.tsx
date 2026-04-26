import React from 'react';
import { Link } from '@inertiajs/react';
import '../../../css/button.css';
interface Props {
    href?: string;
    children: React.ReactNode;
    className?: string;
    type?: "button" | "submit" | "reset";
    onClick?: (e: React.MouseEvent<HTMLElement>) => void;
}

export default function Button({ type, href, children, className,onClick }: Props) {
    if (href) {
        return (
            <Link href={href} className={className} type={type}>
                {children}
            </Link>
        );
    }

    return (
        <button 
            type={type} 
            className={className} 
            onClick={onClick}
        >
            {children}
        </button>
    );
}
