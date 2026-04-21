import { Link, usePage } from '@inertiajs/react';
import React from 'react';
import '../../../css/navbar.css';

const Navbar = () => {
    const { auth } = usePage().props;

    return (
        <nav className="navbar">
            <div className="nav-content">
                <div className="logo">
                    <Link href={'/inicio'}>
                        <img src="/storage/otros/logo.jpg" alt="Arena" />
                    </Link>
                </div>
                <div className="nav-links">
                    <Link href={'/centros'}>Centros</Link>
                    <Link href={'/actividades'}>Actividades</Link>
                    <Link href={'/cursos'}>Cursos</Link>
                    <Link href={'/horario'}>Horario</Link>
                </div>
                <div className="botones-acceso">
                    <Link href={'/register'}>
                        <button className="boton socio">Hazte socio</button>
                    </Link>
                    <Link href={'/login'}>
                        <button className="boton login">
                            <img
                                src="/storage/otros/persona.jpg"
                                alt="Usuario"
                                className="icono-login"
                            />
                            {auth.user ? auth.user.name : 'Iniciar sesión'}
                        </button>
                    </Link>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
