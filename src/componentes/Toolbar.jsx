import React from 'react';
import { Box, AppBar, Button, Typography, Menu, MenuItem } from '@mui/material';
import { useNavigate } from 'react-router-dom';

function Toolbar({ loggedInUser, onLogout }) {
    const navigate = useNavigate();
    const [anchorEl, setAnchorEl] = React.useState(null);

    const handleMenuClick = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleMenuItemClick = (route) => {
        navigate(route);
        setAnchorEl(null);
    };

    const handleMenuClose = () => {
        setAnchorEl(null);
    };

    const handleLoginButtonClick = () => {
        navigate('/login');
    };

    const handleLogoutButtonClick = () => {
        // Lógica para cerrar sesión
        onLogout();
    };

    const handleInicioButtonClick = () => {
        navigate('/');
    };

    

    return (
        <AppBar position="static" sx={{ background: 'linear-gradient(90deg, rgba(21,80,59,1) 0%, rgba(21,80,59,1) 50%)' }}>
            <Box
                sx={{
                    display: 'flex',
                    flexDirection: 'row',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    padding: '10px',
                }}
            >
                <Typography variant="h6" component="div" sx={{ color: 'white', textAlign: 'left' }}>
                    ServiSapito
                </Typography>
                <Typography variant="h6" component="div" sx={{ flexGrow: 1, textAlign: 'center', color: 'white' }}>
                    {loggedInUser ? `Bienvenido, ${loggedInUser}` : ''}
                </Typography>
                <Button color="inherit" onClick={handleInicioButtonClick}>
                        Inicio
                    </Button>
                <Box>
                    {loggedInUser && (
                        <>
                            <Button color="inherit" onClick={handleMenuClick}>
                                Admin
                            </Button>
                            <Menu
                                anchorEl={anchorEl}
                                open={Boolean(anchorEl)}
                                onClose={handleMenuClose}
                                anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
                                transformOrigin={{ vertical: 'top', horizontal: 'right' }}
                            >
                                <MenuItem onClick={() => handleMenuItemClick('/facturas')}>Control de Facturas</MenuItem>
                            </Menu>
                        </>
                    )}
                    
                    <Button color="inherit" onClick={loggedInUser ? handleLogoutButtonClick : handleLoginButtonClick}>
                        {loggedInUser ? 'Cerrar Sesión' : 'Iniciar Sesión'}
                    </Button>
                </Box>
            </Box>
        </AppBar>
    );
}

export default Toolbar;
