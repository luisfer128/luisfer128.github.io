import React from 'react';
import { Box, Container, Grid, Link, Typography, IconButton } from '@mui/material';
import FacebookIcon from '@mui/icons-material/Facebook';
import TwitterIcon from '@mui/icons-material/Twitter';
import InstagramIcon from '@mui/icons-material/Instagram';

function Footer() {
  return (
    <Box component="footer"
        sx={{
            background: 'linear-gradient(90deg, rgba(21,80,59,1) 0%, rgba(21,80,59,1) 50%)',
            color: 'white',
            py: 4,
        }}
    >
        <Container>
            <Grid container spacing={4}>
                <Grid item xs={12} md={4}>
                    <Typography variant="h6" gutterBottom>ServiSapito</Typography>
                    <Link href="#" sx={{ display: 'block', color: 'inherit', mb: 1, '&:hover': { textDecoration: 'underline' } }}>
                        Sobre nosotros
                    </Link>
                    <Link href="#" sx={{ display: 'block', color: 'inherit', mb: 1, '&:hover': { textDecoration: 'underline' } }}>
                        Buscar mi dispositivo
                    </Link>
                </Grid>
                <Grid item xs={12} md={4}>
                    <Typography variant="h6" gutterBottom>Soporte</Typography>
                        <Link href="#" sx={{ display: 'block', color: 'inherit', mb: 1, '&:hover': { textDecoration: 'underline' } }}>
                        Preguntas frecuentes (FAQs)
                    </Link>
                        <Link href="#" sx={{ display: 'block', color: 'inherit', mb: 1, '&:hover': { textDecoration: 'underline' } }}>
                        Contáctanos por correo
                    </Link>
                    <Link href="#" sx={{ display: 'block', color: 'inherit', mb: 1, '&:hover': { textDecoration: 'underline' } }}>
                        Política de reembolso
                    </Link>
                </Grid>
                <Grid item xs={12} md={4}>
                    <Typography variant="h6" gutterBottom>Síguenos</Typography>
                    <Box>
                    <IconButton href="#" sx={{ color: 'inherit', mx: 1 }}>
                        <FacebookIcon />
                    </IconButton>
                    <IconButton href="#" sx={{ color: 'inherit', mx: 1 }}>
                        <TwitterIcon />
                    </IconButton>
                    <IconButton href="#" sx={{ color: 'inherit', mx: 1 }}>
                        <InstagramIcon />
                    </IconButton>
                    </Box>
                </Grid>
            </Grid>
            <Typography variant="body2" align="center" sx={{ mt: 2 }}>
                © Todos los derechos reservados 2024
            </Typography>
        </Container>
    </Box>
  );
}

export default Footer;
