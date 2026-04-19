import React from 'react';
import { Link } from '@inertiajs/react';
import '../../../css/button.css';
interface Props {
    href: string;
    children: React.ReactNode;
    className: string;
    type: string;
}

export default function Button({ type, href, children, className }: Props) {
    return (
        <>
            <Link href={href} className={className} type={type}>
                {children}
            </Link>
        </>
    );
}
