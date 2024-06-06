import React from 'react';
import {Box, Container, Typography, Button, Grid, Paper} from '@mui/material';

function LandingPage() {
    return(
        <Box sx={{ 
            bgcolor: 'background.paper', 
            pt: 8, 
            pb: 6,
             }}>
            <Container maxWidth="sm">
                <Typography component="h1" variant="h2" align="center" color="text.primary" gutterBottom>
                    Bienvenido a ServiSapito
                </Typography>
                <Typography variant="h5" align="center" color="text.secondary" paragraph>
                    Soluciones rápidas y eficientes para la reparación de tu equipo celular. Consulta el estado de tu reparación en cualquier momento.
                </Typography>
                <Box sx={{ display: 'flex', justifyContent: 'center' }}>
                    <Button variant="contained" color="primary" sx={{ m: 1 }}>
                        Ver Estado de Reparación
                    </Button>
                </Box>
            </Container>
            <Container sx={{ mb:2 ,pt: 8, pb: 6 }} item="center">
                <Typography variant="h4" align="center" color="text.primary" gutterBottom>
                    Nuestros Servicios
                </Typography>
                <Grid container spacing={4} align="center">
                    <Grid item xs={12}  md={4} sx={{transition: 'transform 0.3s ease', '&:hover': {
                    transform: 'scale(0.95)'}
                    }}>
                        <Paper sx={{ background: 'rgb(9, 161, 67)', padding: 2, height:148,  display: 'flex', flexDirection: 'column', justifyContent: 'center'  }}>
                            <Typography variant="h5" align="center" color='white' >
                                Reparación de Pantallas
                            </Typography>
                            <Typography align="center" color='white'>
                                Solucionamos cualquier problema de pantalla rota o dañada.
                            </Typography>
                        </Paper>
                    </Grid>
                    <Grid item xs={12}  md={4} sx={{transition: 'transform 0.3s ease', '&:hover': {
                    transform: 'scale(0.95)'}
                    }}>
                        <Paper sx={{ background: 'rgb(9, 161, 67)', padding: 2, height:148,  display: 'flex', flexDirection: 'column', justifyContent: 'center'  }}>
                            <Typography variant="h5" align="center" gutterBottom color='white'>
                                Cambio de Baterías
                            </Typography>
                            <Typography align="center" color='white'>
                                Reemplazamos baterías para asegurar el mejor rendimiento de tu equipo.
                            </Typography>
                        </Paper>
                    </Grid>
                    <Grid item xs={12}  md={4} sx={{transition: 'transform 0.3s ease', '&:hover': {
                    transform: 'scale(0.95)'}
                    }}>
                        <Paper sx={{ background: 'rgb(9, 161, 67)', padding: 2, height:148,  display: 'flex', flexDirection: 'column', justifyContent: 'center'  }}>
                            <Typography variant="h5" align="center" gutterBottom color='white'>
                                Diagnóstico y Reparación
                            </Typography>
                            <Typography align="center" color='white'>
                                Ofrecemos un diagnóstico completo y reparación de cualquier problema.
                            </Typography>
                        </Paper>
                    </Grid>
                </Grid>
            </Container>
        </Box>
    );
}


export default LandingPage;