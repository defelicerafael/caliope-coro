import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TitleToUrlServiceService {

  constructor() { }

  transformString(inputString: any): string {
    // Convierte las vocales con acentos a vocales sin acentos
    const unaccentedString = this.removeAccents(inputString);
  
    // Convierte a minúsculas y reemplaza espacios por guiones
    const lowercaseString = unaccentedString.toLowerCase();
    const alphanumericOnly = lowercaseString.replace(/[^a-zA-Z0-9 ]/g, "");
    const hyphenatedString = alphanumericOnly.replace(/\s+/g, '-');

    // Elimina guiones finales
    const cleanedString = hyphenatedString.replace(/-+$/, '');

    return cleanedString;
  }
  
  removeAccents(str: string): string {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  }
}
