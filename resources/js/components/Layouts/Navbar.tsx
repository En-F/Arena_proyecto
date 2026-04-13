import { Link } from '@inertiajs/react';
import React from 'react';
import '../../../css/navbar.css';

const Navbar = () => {
    return (
        <nav className="navbar">
            <div className="nav-content">
                <div className="logo">
                    <Link href={'/inicio'}>
                        <img src="/images/otros/logo.jpg" alt="Arena" />
                    </Link>
                </div>
                <div className="nav-links">
                    <Link href={'/centros'}>Centros y tarifas</Link>
                    <Link href={'/actividades'}>Actividades</Link>
                    <Link href={'/noticias'}>Noticias</Link>
                    <Link href={'/horario'}>Horario</Link>
                </div>
                <div className="botones-acceso">
                    <Link href={'/socio'}>
                        <button className="boton socio">Hazte socio</button>
                    </Link>
                    <Link href={'/login'}>
                        <button className="boton login">
                            <img
                                src="images/otros/persona.jpg"
                                alt="Usuario"
                                className="icono-login"
                            />
                            Iniciar sesión
                        </button>
                    </Link>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
