import { Injectable } from '@angular/core';
import { ViewportScroller } from '@angular/common';

@Injectable({
  providedIn: 'root'
})
export class ScrollingService {
  onClikScroll(elementId:string){
    console.log(elementId);
    this.viewportScroller.setOffset([0,15]);
    this.viewportScroller.scrollToAnchor(elementId);
  }
  constructor(
    private viewportScroller: ViewportScroller
  ) { }
}
