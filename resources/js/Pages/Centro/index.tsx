import { Head } from '@inertiajs/react';
import '../../../css/centro/inicio.css';
import Button from '@/components/Layouts/Button';
import Carta from '@/components/carta/Cartagenerica';
import { useEffect, useState } from 'react';

interface Centro {
    id: number;
    nombre: string;
    imagen: string;
}

interface Props {
    centros: Centro[];
}

export default function Inicio({ centros }: Props) {
    const [busqueda, setBusqueda] = useState('');
    const [resultado, setResultado] = useState<Centro[]>([]);

    useEffect(() => {
        const buscarAsincrono = async () => {
            if (busqueda.trim() === '') {
                setResultado([]);
                return;
            }
            try {
                const response = await fetch(
                    `/centros/buscar?q=${encodeURIComponent(busqueda)}`,
                );
                const data = await response.json();
                setResultado(data);
            } catch (error) {
                console.error('Error:', error);
            }
        };
        buscarAsincrono();
    }, [busqueda]);

    const centrosAMostrar = busqueda.trim() !== '' ? resultado : centros;

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
                                    value={busqueda}
                                    onChange={(e) =>
                                        setBusqueda(e.target.value)
                                    }
                                />
                            </div>
                        </label>
                    </div>
                    <div className="grid-centros">
                        {centrosAMostrar.map((centro) => (
                            <Carta
                                key={centro.id}
                                id={centro.id}
                                nombre={centro.nombre}
                                imagen={centro.imagen}
                                tipo="centro"
                                rutaDetalle="/centros"
                                rutaOcultar="/centros/ocultar"
                                textoOcultar="Ocultar"
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
