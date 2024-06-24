var SlidePanel = Class.create();

SlidePanel.prototype = {

	initialize: function(windowWidth, step, buttons)
	{
		this.sliding = false;
		if (parseInt(windowWidth) > 0)
			this.windowWidth = windowWidth;
		else
			this.windowWidth = 300;

		if (parseInt(step) > 0)
			this.step = step;
		else
			this.step = 1;

		if (parseInt(buttons) > 0)
		{
			this.buttons = buttons;
			for (var i = 1; i < buttons + 1; i++)
			{
				if ($('prevButton'+i))
					$('prevButton'+i).observe('click', (function(event) { event.stop(); this.prev();}).bindAsEventListener(this));
				if ($('nextButton'+i))
					$('nextButton'+i).observe('click', (function(event) { event.stop(); this.next();}).bindAsEventListener(this));
			}
		}
		else
		{
			if ($('prevButton'))
				$('prevButton').observe('click', (function(event) { event.stop(); this.prev();}).bindAsEventListener(this));
			if ($('nextButton'))
				$('nextButton').observe('click', (function(event) { event.stop(); this.next();}).bindAsEventListener(this));
			this.buttons = 0;
		}

		this.windowWidth = windowWidth;

		this.itemList = $('slidePanel');

		this.fullWidth = this.itemList.getWidth();

		if (this.fullWidth > this.windowWidth)
		{
			this.itemList.setStyle({width: this.windowWidth+'px'});
		}

		this.itemList.scrollLeft = 0;

		this.fixButtons();
	},

	fixButtons: function()
	{
		if (this.buttons > 0) return;

		if (!$('prevButton') || !$('nextButton')) return;

		if (this.fullWidth > this.windowWidth)
		{
			if (this.itemList.scrollLeft + this.windowWidth >= this.fullWidth)
				$('nextButton').setStyle({visibility: 'hidden'});
			else
				$('nextButton').setStyle({visibility: 'visible'});

			if (this.itemList.scrollLeft == 0)
				$('prevButton').setStyle({visibility: 'hidden'});
			else
				$('prevButton').setStyle({visibility: 'visible'});
		}
		else
		{
			$('nextButton').hide();
			$('prevButton').hide();
		}
	},

	scrollSmooth: function(elm, step, left)
	{
		if (left > 0)
		{
			if (step > 0 && elm.scrollLeft + this.windowWidth < this.fullWidth ||
				step < 0 && elm.scrollLeft > 0)
			{
				elm.scrollLeft = elm.scrollLeft + step;
				left = left - Math.abs(step);
				this.scrollSmooth.bind(this).delay(10/1000, elm, step, left);
				this.fixButtons();
				return;
			}
		}
		this.sliding = false;
	},

	next: function()
	{
		if (this.sliding) return;

		this.sliding = true;
		this.scrollSmooth(this.itemList, this.step, this.windowWidth);
	},

	prev: function()
	{
		if (this.sliding) return;

		this.sliding = true;
		this.scrollSmooth(this.itemList, -this.step, this.windowWidth);
	}
}
