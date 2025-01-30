import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BuscardorService {

  private searchData = new BehaviorSubject<any[]>([]);
  private filtros = new BehaviorSubject<{[key: string]: any}[]>([]);
  currentSearchData = this.searchData.asObservable();
  currentFilters = this.filtros.asObservable();

  changeSearchData(data: string[]) {
    this.searchData.next(data);
  }
  
  changeFilters(data:any){
    this.filtros.next(data);
  }

  
  removeFilterByValue(valueToRemove: string) {
    
    const currentFiltros = this.filtros.getValue();
    const updatedFiltros = currentFiltros.map(filtro => {
    const filteredFiltro = Object.keys(filtro).reduce((acc: { [key: string]: any }, key: string) => {
        if (filtro[key] !== valueToRemove) {
          acc[key] = filtro[key];
        }
        return acc;
      }, {});
      return filteredFiltro;
    });
    this.filtros.next(updatedFiltros);
  }
}
