import { TestBed } from '@angular/core/testing';

import { ScrollingIntoViewService } from './scrolling-into-view.service';

describe('ScrollingIntoViewService', () => {
  let service: ScrollingIntoViewService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ScrollingIntoViewService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
