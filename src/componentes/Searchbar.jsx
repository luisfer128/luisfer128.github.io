import React from 'react';
import { InputBase, Button } from '@mui/material';

const searchBarStyle = {
    root: {
      display: 'flex',
      width: '100%',
    },
    input: {
      marginLeft: 1,
      flex: 1,
      
    },
    button: {
      marginLeft: 1,
    },
  };

function SearchBar() {
  return (
    <div className={searchBarStyle.root}>
      <InputBase
        className={searchBarStyle.input}
        placeholder="Buscar"
        inputProps={{ 'aria-label': 'Buscar' }}
      />
      <Button variant="outlined" className={searchBarStyle.button}>
        Buscar
      </Button>
    </div>
  );
}

export default SearchBar;
