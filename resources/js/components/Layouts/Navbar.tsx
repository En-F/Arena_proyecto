import { Link, usePage } from '@inertiajs/react';
import '../../../css/navbar.css';
import Button from './Button';
import '../../../css/button.css';
import { useState } from 'react';

const Navbar = () => {
    const [menuAbierto, setMenuAbierto] = useState(false);
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
                    <Link href={'/reservas'}>Reservas</Link>
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
                            {(auth.user.is_admin || auth.user.is_jefe) && (
                                <Button
                                    onClick={() => setMenuAbierto(!menuAbierto)}
                                    className="boton-perfil-control flex items-center"
                                >
                                    <span className="text-xs font-bold uppercase">
                                        Panel de control
                                    </span>
                                    <span className="ml-4 text-xl leading-none">
                                        {menuAbierto ? '✕' : '☰'}
                                    </span>
                                </Button>
                            )}
                            {menuAbierto && (
                                <div className="absolute top-full right-0 z-50 mt-2 w-56 origin-top-right animate-in rounded-2xl border border-blue-100 bg-white p-2 shadow-2xl duration-200 fade-in zoom-in">
                                    <div className="mb-2 px-3 py-1 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                                        Administración
                                    </div>

                                    <Link
                                        href="/tarifas"
                                        className="flex w-full items-center rounded-xl px-3 py-3 text-sm font-bold text-slate-700 transition-colors hover:bg-blue-50 hover:text-blue-700"
                                        onClick={() => setMenuAbierto(false)}
                                    >
                                        💰 Tarifas
                                    </Link>

                                    <Link
                                        href="/valoraciones"
                                        className="flex w-full items-center rounded-xl px-3 py-3 text-sm font-bold text-slate-700 transition-colors hover:bg-blue-50 hover:text-blue-700"
                                        onClick={() => setMenuAbierto(false)}
                                    >
                                        ⭐ Valoraciones
                                    </Link>

                                    <Link
                                        href="/instalaciones"
                                        className="flex w-full items-center rounded-xl px-3 py-3 text-sm font-bold text-slate-700 transition-colors hover:bg-blue-50 hover:text-blue-700"
                                        onClick={() => setMenuAbierto(false)}
                                    >
                                        🏟️ Instalaciones
                                    </Link>

                                    <div className="my-2 border-t border-slate-100"></div>

                                    <Link
                                        href="/usuarios"
                                        className="flex w-full items-center rounded-xl px-3 py-3 text-sm font-bold text-slate-700 transition-colors hover:bg-blue-50 hover:text-blue-700"
                                        onClick={() => setMenuAbierto(false)}
                                    >
                                        👥 Usuarios
                                    </Link>

                                    <Link
                                        href="/horarios"
                                        className="flex w-full items-center rounded-xl px-3 py-3 text-sm font-bold text-slate-700 transition-colors hover:bg-blue-50 hover:text-blue-700"
                                        onClick={() => setMenuAbierto(false)}
                                    >
                                        🗓️ Gestionar el Horario de Reservas
                                    </Link>

                                    <div className="my-2 border-t border-slate-100"></div>

                                    <Link
                                        method="post"
                                        as="button"
                                        href={route('logout')}
                                        className="flex w-full items-center rounded-xl px-3 py-3 text-sm font-bold text-red-600 transition-colors hover:bg-red-50"
                                    >
                                        ✕ Cerrar Sesión
                                    </Link>
                                </div>
                            )}
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
