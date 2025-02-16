import { TestBed } from '@angular/core/testing';

import { BenchResultsService } from './bench-results.service';

describe('BenchResultsService', () => {
  let service: BenchResultsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BenchResultsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
