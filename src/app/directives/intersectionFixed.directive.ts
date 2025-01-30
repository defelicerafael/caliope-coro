import { afterNextRender, Directive, ElementRef, Input, OnDestroy, OnInit } from '@angular/core';

@Directive({
  standalone:true,
  selector: '[appIntersectionObserverBrief]'
})
export class IntersectionDirectiveBrief implements OnInit, OnDestroy{

  @Input() threshold = 0.5; // Default threshold is 0.5
  
  private observer: IntersectionObserver | undefined;
  
  constructor(private el: ElementRef) {
    afterNextRender(() => {
      if (typeof IntersectionObserver !== 'undefined') {
        const options: IntersectionObserverInit = {
          root: null,
          threshold: this.threshold
        };
    
        this.observer = new IntersectionObserver((entries) => this.handleIntersection(entries), options);
        this.observer.observe(this.el.nativeElement);
        //console.log(this.observer);
      } else {
        // Handle the case where IntersectionObserver is not supported
        //console.error('IntersectionObserver is not supported.');
      }
    });
  }
  
  ngOnInit() {
    
}

  ngOnDestroy() {
    if (this.observer) {
      this.observer.disconnect();
    }
  }

  private handleIntersection(entries: IntersectionObserverEntry[]) {
    console.log('entrando...');
    entries.forEach((entry) => {
      //console.log(entry);
      if (entry.isIntersecting) {
        
        entry.target.classList.add('brief-on');
      } /*else {
        entry.target.classList.remove('brief-on');
        /*entry.target.classList.add('text-off');
      }*/
    });
  }
}
