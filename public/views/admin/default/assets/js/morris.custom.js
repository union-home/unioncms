$(function () {
"use strict";
    Morris.Line({
        element: 'morris-line-chart',
        data: [
			{y: '2006', a: 100, b: 90, c: 80},
            {y: '2007', a: 75, b: 65, c: 55},
            {y: '2008', a: 50, b: 40, c: 30},
            {y: '2009', a: 75, b: 65, c: 55},
            {y: '2010', a: 50, b: 40, c: 30},
            {y: '2011', a: 75, b: 65, c: 55},
            {y: '2012', a: 100, b: 90, c: 80}
			],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Series A', 'Series B', 'Series C'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#5867dd', '#f4516c', '#ffb822']
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [
            {y: '2006', a: 100, b: 90, c: 80},
            {y: '2007', a: 75, b: 65, c: 55},
            {y: '2008', a: 50, b: 40, c: 30},
            {y: '2009', a: 75, b: 65, c: 55},
            {y: '2010', a: 50, b: 40, c: 30},
            {y: '2011', a: 75, b: 65, c: 55},
            {y: '2012', a: 100, b: 90, c: 80}
        ],
        xkey: 'y',
       ykeys: ['a', 'b', 'c'],
        labels: ['Series A', 'Series B', 'Series C'],
        barColors: ['#5867dd', '#f4516c', '#ffb822'],
        hideHover: 'auto',
        resize: true
    });
    Morris.Donut({
  element: 'morris-donut-chart',
  data: [
    {label: "Sales", value: 12},
    {label: "Orders", value: 30},
    {label: "Product", value: 20}
  ],
  backgroundColor: '#fff',
  labelColor: '#666',
  colors: [
    '#5867dd',
    '#f4516c',
    '#ffb822'
  ]
});

 Morris.Area({
        element: 'morris-area-chart',
        data: [{ period: '2010 Q1', iphone: 2666, ipad: null, itouch: 2647 },
            { period: '2010 Q2', iphone: 2778, ipad: 2294, itouch: 2441 },
            { period: '2010 Q3', iphone: 4912, ipad: 1969, itouch: 2501 },
            { period: '2010 Q4', iphone: 3767, ipad: 3597, itouch: 5689 },
            { period: '2011 Q1', iphone: 6810, ipad: 1914, itouch: 2293 },
            { period: '2011 Q2', iphone: 5670, ipad: 4293, itouch: 1881 },
            { period: '2011 Q3', iphone: 4820, ipad: 3795, itouch: 1588 },
            { period: '2011 Q4', iphone: 15073, ipad: 5967, itouch: 5175 },
            { period: '2012 Q1', iphone: 10687, ipad: 4460, itouch: 2028 },
            { period: '2012 Q2', iphone: 8432, ipad: 5713, itouch: 1791 } ],
        xkey: 'period',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        pointSize: false,
        hideHover: 'auto',
        resize: true,
        lineColors: ['#5867dd', '#f4516c', '#ffb822'],
        lineWidth:false,
        pointSize:false
    });

});