import { Link, usePage } from '@inertiajs/react';
import '../../../css/navbar.css';
import Button from './Button';
import '../../../css/button.css';

const Navbar = () => {
    const { auth } = usePage().props;
    const tieneCentro = (auth.user?.centros?.length ?? 0) > 0;
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
                        <div className="flex items-center gap-4">
                            {!auth.user.is_admin &&
                                !auth.user.is_jefe &&
                                !tieneCentro && (
                                    <Link href="/socio">
                                        <Button className="boton-socio">
                                            Hazte Socio
                                        </Button>
                                    </Link>
                                )}

                            <Link href="/settings/profile">
                                <Button className="boton-login-logeado">
                                    <img
                                        src="/storage/otros/persona.jpg"
                                        alt="Usuario"
                                        className="icono-login-logeado"
                                    />
                                    {auth.user.name}
                                </Button>
                            </Link>
                        </div>
                    ) : (
                        <>
                            <Link href="/register">
                                <Button className="boton register">
                                    Registrarse
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button className="boton login">
                                    <img
                                        src="/storage/otros/persona.jpg"
                                        alt="Usuario"
                                        className="icono-login"
                                    />
                                    Iniciar sesión
                                </Button>
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
