import { Head, Link } from '@inertiajs/react';
import '../../../css/centro/inicio.css';
import Button from '@/components/Layouts/Button';
import CartaCentro from '@/components/carta/CartaCentro';

interface Props {
    centros: any[];
}

export default function Inicio({ centros }: Props) {
    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                <section className="section-centros">
                    <h2 className="title-black">Nuestros Centros</h2>
                    <p className="descripcion-centros">
                        Conoce nuestro centro, un espacio diseñado para
                        motivarte, acompañarte y ayudarte a superar tus límites
                        con instalaciones modernas, entrenadores profesionales y
                        un ambiente único en el que cada detalle está pensado
                        para tu bienestar.
                    </p>

                    <div className="buscador_centro">
                        <label htmlFor="buscar">
                            Buscador de Centros:
                            <div className="input-wrapper">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    strokeWidth={1.5}
                                    stroke="currentColor"
                                    className="input-icon"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                                    />
                                </svg>
                                <input
                                    id="buscar"
                                    type="text"
                                    placeholder="Nombre de un centro"
                                />
                            </div>
                        </label>
                    </div>
                    <div className="grid-centros">
                        {centros.map((centro) => (
                            <CartaCentro
                                id={centro.id}
                                nombre={centro.nombre}
                                imagen={centro.imagen}
                            />
                        ))}
                    </div>
                    <Button href="/inicio" className="btn-volver btn-crud">
                        Volver
                    </Button>
                </section>
            </div>
        </>
    );
}
