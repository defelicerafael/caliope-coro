import { isPlatformBrowser } from '@angular/common';
import { afterNextRender, ChangeDetectorRef, Inject, Injectable, PLATFORM_ID } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BuscadorstorageService {
  private searchData = new BehaviorSubject<any[]>(this.getFromSessionStorage('searchData') || []);
  private filtros = new BehaviorSubject<{[key: string]: any}[]>(this.getFromSessionStorage('filtros') || []);
  
  currentSearchData = this.searchData.asObservable();
  currentFilters = this.filtros.asObservable();

  constructor(@Inject(PLATFORM_ID) private platformId: Object) {
    afterNextRender(() => {
      this.loadFromSessionStorage();
    });
  }

  private getFromSessionStorage(key: string): any {
    if (isPlatformBrowser(this.platformId)) {
      const data = sessionStorage.getItem(key);
      //console.log(sessionStorage);
      return data ? JSON.parse(data) : null;
    }
  }

  private saveToSessionStorage(key: string, value: any): void {
    if (isPlatformBrowser(this.platformId)) {
      sessionStorage.setItem(key, JSON.stringify(value));
      //console.log(sessionStorage);
    }
  }

  changeSearchData(data: string[]) {
    this.searchData.next(data);
    this.saveToSessionStorage('searchData', data);
  }
  
  changeFilters(data: any[]) {
    this.filtros.next(data);
    this.saveToSessionStorage('filtros', data);
  }

  removeFilterByValue(valueToRemove: string) {
    console.log(valueToRemove);
    const currentFiltros = this.filtros.getValue();
    console.log(currentFiltros);
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
    this.saveToSessionStorage('filtros', updatedFiltros);
  }

  removeFilterByWord(valueToRemove: string) {
    //console.log(valueToRemove);
    const currentFiltros = this.filtros.getValue();
    //console.log(currentFiltros);
  
    const updatedFiltros = currentFiltros.map(filtro => {
      const filteredFiltro = Object.keys(filtro).reduce((acc: { [key: string]: any }, key: string) => {
        // Dividimos el valor por comas para manejar múltiples entradas
        const valuesArray = filtro[key].split(',').map((value: string) => value.trim());
  
        // Filtramos el valor que se quiere eliminar
        const updatedValuesArray = valuesArray.filter((value: string) => value !== valueToRemove);
  
        // Si hay valores restantes, los volvemos a unir en una cadena, sino eliminamos la clave
        if (updatedValuesArray.length > 0) {
          acc[key] = updatedValuesArray.join(', ');
        }
  
        return acc;
      }, {});
  
      return filteredFiltro;
    });
  
    this.filtros.next(updatedFiltros);
    this.saveToSessionStorage('filtros', updatedFiltros);
  }

  private loadFromSessionStorage() {
    const filtros = this.getFromSessionStorage('filtros');
    //console.log(filtros);
    if (filtros) {
      this.filtros.next(filtros);
    }
  }
}
