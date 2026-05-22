import React from 'react';
import '../../../css/footer.css';
import { Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

const Footer = () => {
    return (
        <footer className="footer">
            <div className="footer__contenedor">
                <div className="footer__body">
                    <div className="footer__description-colum1">
                        <p className="footer__description">
                            Transforma tu esfuerzo en resultados. En{' '}
                            <span className="footer__arena_title">Arena</span>,
                            entendemos que el deporte es mucho más que
                            ejercicio; es el motor del cambio personal y la
                            disciplina. Únete a nuestra comunidad global de
                            atletas, comparte tus logros y desafía tus propios
                            límites cada día.
                        </p>
                    </div>

                    <div className="footer__links-colum1">
                        <div>
                            <h6 className="footer__link__grupo_title">Ayuda</h6>
                            <nav className="footer__links-nav">
                                <Link
                                    href={route('contacto.inicio')}
                                    className="footer__link"
                                >
                                    Contacto
                                </Link>
                                <Link
                                    href={route('nosotros.inicio')}
                                    className="footer__link"
                                >
                                    Sobre Nosotros
                                </Link>
                            </nav>
                        </div>
                    </div>
                </div>

                <div className="footer__barra_inferior">
                    <p className="footer__copyright">
                        Desarrollado por Enrique Franco Ulric para la ayuda de
                        la gestión de reservas de actividades de centros
                        deportivos.
                    </p>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
