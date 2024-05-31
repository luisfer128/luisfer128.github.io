import './App.css';
import Toolbar from './componentes/Toolbar';
import SearchBar from './componentes/Searchbar';
import sapoLandingImage from './images/sapo-landing.webp'; 

function App() {
  return (
    <div className="App">
      <Toolbar />
      <div className="content">
        <header className="App-header">
        <SearchBar/>  
        </header>
        <div>
          <img src={sapoLandingImage} alt="Sapo Landing" className='imagen-landing' />
        </div>
      </div>
    </div>
  );
}

export default App;
