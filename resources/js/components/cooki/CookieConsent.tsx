import React, { useEffect, useState } from 'react'

const CookieConsent = () => {

    const [isVisible, setIsVisible] = useState(false);
    const [preferencias , setPreferencias] = useState({
        necesarias: false,
        estadisticas: false,
        adicionales: false
    });

    useEffect(() => {
        const consent = localStorage.getItem('cookieConsent');
        if (!consent) {
            setIsVisible(true);
        }
    }, []);

    const savePreferences = () => {
        localStorage.setItem('cookieConsent', JSON.stringify(preferencias));
        setIsVisible(false);
    };

    if (!isVisible) return null;

  return (
    <div>
      <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div className="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full">
                <p className="mb-4 text-sm text-gray-700 ">
                    Este sitio web utiliza cookies para que usted tenga la mejor experiencia. 
                    Por favor, vea nuestra <a href="/politica-cookies" className="text-blue-500 underline">política de cookies</a>.
                </p>

                {/* Switches */}
                <div className="space-y-4 mb-6">
                <div className="flex items-center justify-between p-2 border-b">
                    <label>Cookies estrictamente necesarias</label>
                    <input type="checkbox" checked disabled className="checkbox checkbox-primary" />
                </div>

                {/* Estadísticas */}
                <div className="flex items-center justify-between p-2 border-b">
                    <label>Cookies de estadísticas</label>
                    <input 
                        type="checkbox" 
                        className="checkbox checkbox-info" 
                        checked={preferencias.estadisticas}
                        onChange={(e) => setPreferencias({...preferencias, estadisticas: e.target.checked})} 
                    />
                </div>

                {/* Adicionales */}
                <div className="flex items-center justify-between p-2 border-b">
                    <label>Cookies adicionales</label>
                    <input 
                        type="checkbox" 
                        className="checkbox checkbox-info" 
                        checked={preferencias.adicionales}
                        onChange={(e) => setPreferencias({...preferencias, adicionales: e.target.checked})} 
                    />
                </div>
            </div>

                {/* Botones */}
                <div className="flex gap-4">
                    <button onClick={() => { setPreferencias({necesarias: true, estadisticas: true, adicionales: true}); savePreferences(); }} 
                            className="btn bg-blue-500 text-white flex-1">Aceptar todas</button>
                    <button onClick={savePreferences} 
                            className="btn bg-blue-500 text-white flex-1">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
  )
}

export default CookieConsent
