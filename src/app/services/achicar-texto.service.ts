import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AchicarTextoService {

  constructor() { }

  /*achicar(text: string, maxWords: number): string {
    const words = text.split(' ');
    if (words.length <= maxWords) {
      return text;
    } else {
      return words.slice(0, maxWords).join(' ') + '...';
    }
  }*/

  achicar(text: string, maxWords: number): string {
    const words = text.split(' ');
    if (words.length <= maxWords) {
      return text;
    }
    let endIndex = maxWords;
    for (let i = 0; i < words.length; i++) {
        if (words[i].includes('<br/>')) {
            endIndex = i;
            break;
        }
    }
    if (endIndex >= maxWords) {
        return words.slice(0, maxWords).join(' ') + '...';
    } else {
        return words.slice(0, endIndex).join(' ') + '...';
    }
}

}
