import React, { useEffect, useState } from 'react';

const CookieConsent = () => {
    const [isVisible, setIsVisible] = useState(false);
    const [preferencias, setPreferencias] = useState({
        necesarias: true,
        estadisticas: false,
        adicionales: false,
        fecha: null,
        pais: 'Desconocido',
    });

    useEffect(() => {
        const consent = localStorage.getItem('cookieConsent');
        if (!consent) {
            fetch('https://ipapi.co/json/')
                .then((res) => res.json())
                .then((data) => {
                    setPreferencias((prev) => ({
                        ...prev,
                        pais: data.country_name,
                    }));
                });
            setIsVisible(true);
        }
    }, []);

    const savePreferences = (datos = preferencias) => {
        const datosA_Guardar = {
            ...datos,
            fecha: new Date().toLocaleString(),
        };

        localStorage.setItem('cookieConsent', JSON.stringify(datosA_Guardar));
        setIsVisible(false);
    };

    if (!isVisible) return null;

    return (
        <div>
            <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div className="w-full max-w-lg rounded-lg bg-white p-8 shadow-xl">
                    <p className="mb-4 text-sm text-gray-700">
                        Este sitio web utiliza cookies para que usted tenga la
                        mejor experiencia. Por favor, vea nuestra{' '}
                        <a
                            href="/politica-cookies"
                            className="text-blue-500 underline"
                        >
                            política de cookies
                        </a>
                        .
                    </p>

                    {/* Switches */}
                    <div className="mb-6 space-y-4">
                        <div className="flex items-center justify-between border-b p-2">
                            <label>Cookies estrictamente necesarias</label>
                            <input
                                type="checkbox"
                                checked
                                disabled
                                className="checkbox checkbox-primary"
                            />
                        </div>

                        {/* Estadísticas */}
                        <div className="flex items-center justify-between border-b p-2">
                            <label>Cookies de estadísticas</label>
                            <input
                                type="checkbox"
                                className="checkbox checkbox-info"
                                checked={preferencias.estadisticas}
                                onChange={(e) =>
                                    setPreferencias({
                                        ...preferencias,
                                        estadisticas: e.target.checked,
                                    })
                                }
                            />
                        </div>

                        {/* Adicionales */}
                        <div className="flex items-center justify-between border-b p-2">
                            <label>Cookies adicionales</label>
                            <input
                                type="checkbox"
                                className="checkbox checkbox-info"
                                checked={preferencias.adicionales}
                                onChange={(e) =>
                                    setPreferencias({
                                        ...preferencias,
                                        adicionales: e.target.checked,
                                    })
                                }
                            />
                        </div>
                    </div>

                    {/* Botones */}
                    <div className="flex gap-4">
                        <button
                            onClick={() => {
                                const aceptarTodo = {
                                    ...preferencias,
                                    necesarias: true,
                                    estadisticas: true,
                                    adicionales: true,
                                };
                                savePreferences(aceptarTodo);
                            }}
                            className="btn flex-1 bg-blue-500 text-white"
                        >
                            Aceptar todas
                        </button>
                        <button
                            onClick={() => savePreferences()}
                            className="btn flex-1 bg-blue-500 text-white"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CookieConsent;