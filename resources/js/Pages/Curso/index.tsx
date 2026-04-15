import { Head, Link } from '@inertiajs/react';
import Button from '@/components/Layouts/Button';
import CartaCentro from '@/components/carta/CartaCentro';

interface Props {
    cursos: any[];
}

export default function Inicio({ cursos }: Props) {
    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                {/* --- SECCIÓN CENTROS --- */}
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
                    <div className="grid-centros">
                        {cursos.map((curso) => (
                            <Link
                                key={curso.id}
                                href={`/cursos/${curso.id}`}
                                className="centro-item"
                            >
                                <div className="img-card-container">
                                    <img
                                        src={`/images/cursos/${curso.id}.jpg`}
                                        alt={curso.nombre}
                                    />
                                </div>
                                <p className="centro-title">{curso.titulo}</p>
                            </Link>
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
