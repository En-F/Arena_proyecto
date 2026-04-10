// resources/js/Layouts/MainLayout.jsx
import React from 'react';
import Footer from '@/components/Layouts/Footer';
import Navbar from '@/components/Layouts/Navbar';
import '../../css/mainlayouts.css';

interface Props {
    children: React.ReactNode;
    title?: string;
    description?: string;
}

export default function MainLayout({ children, title, description }: Props) {
    return (
        <div className="main-container">
            <Navbar />

            <main className="flex-grow pt-10">
                {title && <h1 className="text-2xl font-bold">{title}</h1>}

                {children}
            </main>

            <Footer />
        </div>
    );
}
