import { Link, usePage } from '@inertiajs/react';
import '../../../css/navbar.css';
import Button from './Button';
import '../../../css/button.css';
import { useEffect, useState } from 'react';

const Navbar = () => {
    const [menuAdminAbierto, setMenuAdminAbierto] = useState(false);
    const [hamburguesaAbierta, setHamburguesaAbierta] = useState(false);
    const { auth } = usePage().props;
    const tieneCentro = (auth.user?.centros?.length ?? 0) > 0;

    useEffect(() => {
        setMenuAdminAbierto(false);
        setHamburguesaAbierta(false);
    }, [auth.user?.id]);

    return (
        <nav className="navbar">
            <div className="nav-content">
                <div className="nav-left">
                    <div className="logo">
                        <Link href={'/inicio'}>
                            <img src="/storage/otros/logo.jpg" alt="Arena" />
                        </Link>
                    </div>

                    <button
                        className="menu-hamburguesa"
                        onClick={() =>
                            setHamburguesaAbierta(!hamburguesaAbierta)
                        }
                    >
                        {hamburguesaAbierta ? '✕' : '☰'}
                    </button>

                    <div
                        className={`nav-links ${hamburguesaAbierta ? 'activo' : ''}`}
                    >
                        <Link
                            href={'/centros'}
                            onClick={() => setHamburguesaAbierta(false)}
                        >
                            Centros
                        </Link>
                        <Link
                            href={'/actividades'}
                            onClick={() => setHamburguesaAbierta(false)}
                        >
                            Actividades
                        </Link>
                        <Link
                            href={'/cursos'}
                            onClick={() => setHamburguesaAbierta(false)}
                        >
                            Cursos
                        </Link>
                        <Link
                            href={'/reservas'}
                            onClick={() => setHamburguesaAbierta(false)}
                        >
                            Reservas
                        </Link>
                    </div>
                </div>

                <div className="nav-right">
                    <div className="botones-acceso">
                        {auth.user ? (
                            <div className="user-actions-container">
                                {!auth.user.is_admin &&
                                    !auth.user.is_jefe &&
                                    !tieneCentro && (
                                        <Link href={route('socio.create')}>
                                            <Button className="boton-socio">
                                                Hazte Socio
                                            </Button>
                                        </Link>
                                    )}

                                <Link href="/settings/profile">
                                    <Button className="boton-perfil-user">
                                        <img
                                            src="/storage/otros/persona.jpg"
                                            alt="User"
                                            className="icono-perfil"
                                        />
                                        <span className="user-name">
                                            {auth.user.name}
                                        </span>
                                    </Button>
                                </Link>

                                {(auth.user.is_admin || auth.user.is_jefe) && (
                                    <div className="admin-menu-wrapper">
                                        <Button
                                            onClick={() =>
                                                setMenuAdminAbierto(
                                                    !menuAdminAbierto,
                                                )
                                            }
                                            className="btn-panel-control"
                                        >
                                            <span className="panel-text-visible">
                                                Panel
                                            </span>
                                            <span className="icon-flecha">
                                                {menuAdminAbierto ? '✕' : '▾'}
                                            </span>
                                        </Button>

                                        {menuAdminAbierto && (
                                            <div className="dropdown-admin">
                                                <div className="dropdown-header">
                                                    Administración
                                                </div>
                                                <Link
                                                    href="/tarifas"
                                                    className="dropdown-item"
                                                    onClick={() =>
                                                        setMenuAdminAbierto(
                                                            false,
                                                        )
                                                    }
                                                >
                                                    💰 Tarifas
                                                </Link>
                                                <Link
                                                    href="/valoraciones"
                                                    className="dropdown-item"
                                                    onClick={() =>
                                                        setMenuAdminAbierto(
                                                            false,
                                                        )
                                                    }
                                                >
                                                    ⭐ Valoraciones
                                                </Link>
                                                <Link
                                                    href="/instalaciones"
                                                    className="dropdown-item"
                                                    onClick={() =>
                                                        setMenuAdminAbierto(
                                                            false,
                                                        )
                                                    }
                                                >
                                                    🏟️ Instalaciones
                                                </Link>
                                                <div className="dropdown-divider"></div>
                                                <Link
                                                    href="/usuarios"
                                                    className="dropdown-item"
                                                    onClick={() =>
                                                        setMenuAdminAbierto(
                                                            false,
                                                        )
                                                    }
                                                >
                                                    👥 Usuarios
                                                </Link>
                                                <Link
                                                    href="/horarios"
                                                    className="dropdown-item"
                                                    onClick={() =>
                                                        setMenuAdminAbierto(
                                                            false,
                                                        )
                                                    }
                                                >
                                                    🗓️ Horarios
                                                </Link>
                                                <div className="dropdown-divider"></div>
                                                <Link
                                                    method="post"
                                                    as="button"
                                                    href={route('logout')}
                                                    className="dropdown-item logout-text"
                                                >
                                                    ✕ Cerrar Sesión
                                                </Link>
                                            </div>
                                        )}
                                    </div>
                                )}
                            </div>
                        ) : (
                            <div className="guest-actions">
                                <Link href="/register">
                                    <Button className="btn-nav btn-register">
                                        Registrarse
                                    </Button>
                                </Link>
                                <Link href="/login">
                                    <Button className="btn-nav btn-login">
                                        <img
                                            src="/storage/otros/persona.jpg"
                                            alt="Login"
                                            className="icono-login-btn"
                                        />
                                        <span>Iniciar sesión</span>
                                    </Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
