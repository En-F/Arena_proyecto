import { Link, usePage } from '@inertiajs/react';
import React from 'react';
import '../../../css/navbar.css';

const Navbar = () => {
    const { auth } = usePage().props;
    console.log(auth.user);
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
                    <Link href={'/horarios'}>Horario</Link>
                    {auth.user && (auth.user.is_admin || auth.user.is_jefe) && (
                        <Link href={'/usuarios'}>Usuarios</Link>
                    )}
                </div>
                <div className="botones-acceso">
                    {auth.user ? (
                        <Link href={auth.user ? '/settings/profile' : '/login'}>
                            <button className="boton-login-logeado">
                                <img
                                    src="/storage/otros/persona.jpg"
                                    alt="Usuario"
                                    className="icono-login-logeado"
                                />
                                {auth.user.name}
                            </button>
                        </Link>
                    ) : (
                        <>
                            <Link href="/socio">
                                <button className="boton socio">
                                    Hazte Socio
                                </button>
                            </Link>

                            <Link href="/login">
                                <button className="boton login">
                                    <img
                                        src="/storage/otros/persona.jpg"
                                        alt="Usuario"
                                        className="icono-login"
                                    />
                                    Iniciar sesión
                                </button>
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
