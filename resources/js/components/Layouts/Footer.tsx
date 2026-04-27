import React from 'react';
import '../../../css/footer.css';

const Footer = () => {
    return (
        <footer className="footer">
            <div className="footer__contenedor">
                <div className="footer__pregunta">
                    <strong className="footer__pregunta-title">
                        ¿Quieres recibir las últimas noticias de Arena?
                    </strong>

                    <form className="footer__pregunta-form">
                        <div className="footer__input-contenido">
                            <label
                                className="footer__input-label"
                                htmlFor="email"
                            >
                                {' '}
                                Email{' '}
                            </label>
                            <input
                                className="footer__input"
                                id="email"
                                type="email"
                                placeholder="Ejemplo@gmail.com"
                            />
                            <button className="footer__subscribe-btn">
                                Suscribirse
                            </button>
                        </div>
                    </form>
                </div>

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

                    <div className="footer__links-colum2">
                        <div>
                            <h6 className="footer__link__grupo_title">Legal</h6>
                            <nav className="footer__links-nav">
                                <a className="footer__link">Términos de uso</a>
                                <a className="footer__link">
                                    Politica de privacidad
                                </a>
                            </nav>
                        </div>

                        <div>
                            <h6 className="footer__link__grupo_title">Ayuda</h6>
                            <nav className="footer__links-nav">
                                <a className="footer__link">Contacto</a>
                                <a className="footer__link">Sobre Nosotros</a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div className="footer__barra_inferior">
                    
                    <p className="footer__copyright">
                        Desarrollado por Enrique Franco Ulric para la ayuda de
                        la gestión de un centro de deporte.
                    </p>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
