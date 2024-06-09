import './App.css';
import Toolbar from './componentes/Toolbar';
import SearchBar from './componentes/Searchbar';
import sapoLandingImage from './images/sapo-landing.webp'; 
import LandingPage from './componentes/LandingPage';
import Footer from './componentes/Footer';


//


function App() {

  

  return (
    <div className="App">
      <Toolbar />
      <div className="content">
        <header className="App-header">
        <LandingPage />
        <SearchBar />    
          <img src={sapoLandingImage} alt="Sapo Landing" className='imagen-landing' />
        </header>
        <div>
        <Footer />
        </div>
      </div>
    </div>
  );
}

export default App;
