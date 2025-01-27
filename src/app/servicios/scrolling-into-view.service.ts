import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ScrollingIntoViewService {

  constructor() { }
  scrollTo(element: HTMLElement): void {
    //console.log(element);
    if (element) {
      element.scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });
    }
  }
}
