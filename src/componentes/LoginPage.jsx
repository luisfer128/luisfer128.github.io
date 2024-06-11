import React, { useState } from 'react';
import { Box, Button, TextField, Typography, CircularProgress } from '@mui/material';
import { useNavigate } from 'react-router-dom';

function LoginPage({ onLogin }) {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleLogin = async () => {
        setLoading(true);
        setError('');
    
        try {
            const response = await fetch('http://100.113.27.1:3200/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username, password }),
            });
    
            if (response.ok) {
                const data = await response.json();
                const { username } = data;
                onLogin(username); // Llama a la función onLogin con el nombre de usuario
                navigate('/');
            } else {
                setError('Credenciales incorrectas o no existentes');
            }
        } catch (error) {
            console.error('Error al iniciar sesión:', error);
            setError('Error al iniciar sesión. Por favor, intenta nuevamente.');
        } finally {
            setLoading(false);
        }
    };
    

    return (
        <Box
            sx={{
                display: 'flex',
                flexDirection: 'column',
                justifyContent: 'center',
                alignItems: 'center',
                minHeight: 'calc(100vh - 64px)', // Resta el tamaño de la barra de navegación
                padding: '16px',
            }}
        >
            <Typography component="h1" variant="h4" color="text.primary">
                Iniciar Sesión
            </Typography>
            <Box sx={{ width: '100%', maxWidth: 400 }}>
                <TextField
                    label="Nombre de Usuario"
                    value={username}
                    onChange={(e) => setUsername(e.target.value)}
                    fullWidth
                    margin="normal"
                    InputLabelProps={{ style: { color: 'black' } }}
                    InputProps={{ style: { color: 'black' } }}
                />
                <TextField
                    label="Contraseña"
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    fullWidth
                    margin="normal"
                    InputLabelProps={{ style: { color: 'black' } }}
                    InputProps={{ style: { color: 'black' } }}
                />
                {error && (
                    <Typography color="error" sx={{ mt: 2 }}>
                        {error}
                    </Typography>
                )}
                <Button
                    variant="contained"
                    color="primary"
                    onClick={handleLogin}
                    disabled={loading}
                    fullWidth
                    sx={{ mt: 2, display: 'flex', alignItems: 'center', justifyContent: 'center' }}
                >
                    {loading ? <CircularProgress size={24} sx={{ color: 'white', mr: 2 }} /> : 'Iniciar Sesión'}
                    {loading ? 'Cargando...' : ''}
                </Button>
            </Box>
        </Box>
    );
}

export default LoginPage;