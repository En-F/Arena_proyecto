import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Button from '@/components/Layouts/Button';
import '../../../css/noticia/formulario.css';

interface Props {
    beneficios: Array<{ id: number; titulo: string }>;
    curso: { id: number; nombre: string };
}

export default function Biblioteca({ beneficios, curso }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        beneficio_id: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        post(route('cursos.beneficios.asociar', curso.id));
    };

    return (
        <div className="cn-page">
            <div className="cn-wrap">
                <div className="cn-section-header">
                    <p className="cn-section-title">
                        Añadir Beneficio al curso: {curso.nombre}
                    </p>
                    <p className="cn-section-subtitle">
                        Selecciona un beneficio de la biblioteca para asociarlo.
                    </p>
                </div>

                <form onSubmit={handleSubmit} className="mt-6">
                    <div className="cn-field">
                        <label className="cn-label">
                            Beneficios disponibles
                        </label>
                        <select
                            className="cn-input w-full"
                            value={data.beneficio_id}
                            onChange={(e) =>
                                setData('beneficio_id', e.target.value)
                            }
                        >
                            <option value="">Selecciona un beneficio...</option>
                            {beneficios.map((b) => (
                                <option key={b.id} value={b.id}>
                                    {b.titulo}
                                </option>
                            ))}
                        </select>
                        {errors.beneficio_id && (
                            <span className="text-xs text-red-500">
                                {errors.beneficio_id}
                            </span>
                        )}
                    </div>

                    <div className="cn-actions mt-8">
                        <Button
                            href={route('cursos.show', curso.id)}
                            type="button"
                            className="cn-btn-cancel"
                        >
                            Volver
                        </Button>
                        <Button
                            type="submit"
                            className="cn-btn-save"
                            disabled={processing || !data.beneficio_id}
                        >
                            {processing ? 'Vinculando...' : 'Asociar al curso'}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    );
}
