import { Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import Button from '@/components/Layouts/Button';
import CartaCentro from '@/components/carta/CartaCentro';
import '../../../css/centro/inicio.css';
import Carta from '@/components/carta/Cartagenerica';

interface Curso {
    id: number;
    titulo: string;
    imagen: string;
}

interface Props {
    cursos: Curso[];
}

export default function Inicio({ cursos }: Props) {
    const [busqueda, setBusqueda] = useState('');
    const [resultado, setResultado] = useState<Curso[]>([]);

    useEffect(() => {
        const buscarAsincrono = async () => {
            if (busqueda.trim() === '') {
                setResultado([]);
                return;
            }
            try {
                const response = await fetch(
                    `/cursos/buscar?q=${encodeURIComponent(busqueda)}`,
                );
                const data = await response.json();
                setResultado(data);
            } catch (error) {
                console.error('Error:', error);
            }
        };
        buscarAsincrono();
    }, [busqueda]);

    const cursosAMostrar = busqueda.trim() !== '' ? resultado : cursos;

    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                <section className="section-centros">
                    <h2 className="title-black">Nuestros Cursos</h2>
                    <p className="descripcion-centros">
                        Conoce nuestros cursos, una variedad de programas
                        diseñados para ayudarte a alcanzar tus objetivos de
                        fitness, mejorar tu salud y bienestar, y disfrutar de
                        una experiencia única en cada sesión. Nuestros cursos
                        están dirigidos por entrenadores profesionales y se
                        adaptan a todos los niveles de condición física, desde
                        principiantes hasta atletas avanzados. Ya sea que
                        busques clases de yoga, entrenamiento funcional, pilates
                        o cualquier otra disciplina, tenemos el curso perfecto
                        para ti.
                    </p>

                    <div className="buscador_centro">
                        <label htmlFor="buscar">
                            Buscador de Cursos:
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
                                    placeholder="Nombre de un curso"
                                    value={busqueda}
                                    onChange={(e) =>
                                        setBusqueda(e.target.value)
                                    }
                                />
                            </div>
                        </label>
                    </div>
                    <div className="grid-centros">
                        {cursosAMostrar.map((curso) => (
                            <Carta
                                key={curso.id}
                                id={curso.id}
                                nombre={curso.titulo}
                                imagen={curso.imagen}
                                tipo="curso"
                                rutaDetalle="/cursos"
                                rutaOcultar="/cursos/ocultar"
                                textoOcultar="Ocultar"
                                textoConfirmacion="¿Estás seguro de que quieres ocultar este curso?"
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
