import FilterForm from './FilterForm';
import { BrowserRouter, Routes, Route } from 'react-router-dom';

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<FilterForm />} />
      </Routes>
      
    </BrowserRouter>
  );
}

export default App
