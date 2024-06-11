import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Toolbar from './componentes/Toolbar';
import LandingPage from './componentes/LandingPage';
import Footer from './componentes/Footer';
import LoginPage from './componentes/LoginPage';
import Factura from './componentes/Factura'; // Asegúrate de importar Factura correctamente


function App() {
    const [loggedInUser, setLoggedInUser] = useState(null);

    const handleLogin = (username) => {
        setLoggedInUser(username);
    };

    const handleLogout = () => {
        setLoggedInUser(null); // Elimina el usuario actualmente conectado al cerrar sesión
    };

    return (
        <Router>
            <div className="App">
            <Toolbar loggedInUser={loggedInUser} onLogout={handleLogout} />
                <div className="content">
                    <header className="App-header">
                        <Routes>
                            <Route path="/" element={<LandingPage />} />
                            <Route path="/login" element={<LoginPage onLogin={handleLogin} />} />
                            <Route path="/crear-factura" element={<Factura />} />
                            <Route path="/eliminar-factura" element={<Factura />} />
                            <Route path="/actualizar-factura" element={<Factura />} />
                        </Routes>
                    </header>
                    <Footer />
                </div>
            </div>
        </Router>
    );
}

export default App;
