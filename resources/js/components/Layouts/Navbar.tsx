import { Link } from '@inertiajs/react';
import React from 'react';
import '../../../css/navbar.css';

const Navbar = () => {
    return (
        <nav className="navbar">
            <div className="nav-content">
                <div className="logo">
                    <Link href={'/'}>
                        <img src="/images/otros/logo.png" alt="Arena" />
                    </Link>
                </div>
                <div className="nav-links">
                    <Link href="#">Cursos y tarifas</Link>
                    <Link href="#">Actividades</Link>
                    <Link href="#">Centro</Link>
                    <Link href="#">Horario</Link>
                </div>
                <div className="botones-acceso">
                    <Link href={'/socio'}>
                        <button className="boton socio">Hazte socio</button>
                    </Link>
                    <Link href={'/login'}>
                        <button className="boton login">
                            <img
                                src="images/otros/usuario.png"
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
