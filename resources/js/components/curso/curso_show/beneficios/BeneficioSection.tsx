import { usePage, router } from '@inertiajs/react';
import { Edit3, Trash2, Plus } from 'lucide-react';
import { route } from 'ziggy-js';
import Button from '@/components/Layouts/Button';
import '../../../../../css/curso/beneficiosection.css';

interface Beneficio {
    id: number;
    titulo: string;
    descripcion: string;
}

interface BeneficiosSectionProps {
    beneficios: Beneficio[];
    cursoId: number;
}

export default function BeneficiosSection({
    beneficios,
    cursoId,
}: BeneficiosSectionProps) {
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const handleEdit = (beneficioId: number) => {
        router.get(route('beneficios.edit', beneficioId), {
            curso_id: cursoId,
        });
    };

    const handleDelete = (beneficioId: number) => {
        if (confirm('¿Estás seguro de que quieres eliminar este beneficio?')) {
            router.delete(route('beneficios.destroy', beneficioId), {
                data: { curso: cursoId },
                preserveScroll: true,
            });
        }
    };

    return (
        <section className="beneficios-section">
            <div className="section-header">
                <h2 className="section-title">Beneficios que se obtienen</h2>
                {(is_admin || is_jefe) && (
                    <div className="section-actions">
                        <Button
                            href={route('beneficios.create', {
                                curso_id: cursoId,
                            })}
                            className="btn-add"
                        >
                            <Plus size={18} />
                            Crear
                        </Button>
                        <Button
                            href={route('beneficios.biblioteca', {
                                curso_id: cursoId,
                            })}
                            className="btn-add btn-add-library"
                        >
                            <Plus size={18} />
                            De biblioteca
                        </Button>
                    </div>
                )}
            </div>

            <div className="benefits-grid">
                {beneficios.length > 0 ? (
                    beneficios.map((beneficio, index) => (
                        <div
                            key={beneficio.id || index}
                            className="benefit-card"
                            style={{
                                animationDelay: `${index * 0.1}s`,
                            }}
                        >
                            <div className="benefit-accent"></div>
                            <h3 className="benefit-title">
                                {beneficio.titulo}
                            </h3>
                            <p className="benefit-text">
                                {beneficio.descripcion}
                            </p>

                            {(is_admin || is_jefe) && (
                                <div className="benefit-actions">
                                    <button
                                        onClick={() => handleEdit(beneficio.id)}
                                        className="btn-card-action btn-edit-card"
                                        title="Editar"
                                    >
                                        <Edit3 size={16} />
                                    </button>
                                    <button
                                        onClick={() =>
                                            handleDelete(beneficio.id)
                                        }
                                        className="btn-card-action btn-delete-card"
                                        title="Eliminar"
                                    >
                                        <Trash2 size={16} />
                                    </button>
                                </div>
                            )}
                        </div>
                    ))
                ) : (
                    <div className="empty-state">
                        <p>No hay beneficios añadidos aún</p>
                        {(is_admin || is_jefe) && (
                            <p className="empty-action">
                                <Button
                                    href={route('beneficios.create', {
                                        curso_id: cursoId,
                                    })}
                                    className="btn-add-empty"
                                >
                                    <Plus size={16} />
                                    Añade el primero
                                </Button>
                            </p>
                        )}
                    </div>
                )}
            </div>
        </section>
    );
}
