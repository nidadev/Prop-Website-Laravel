<aside class="position-fixed bottom-0 end-0 m-3" style="z-index:1050;max-width:calc(100vw - 2rem)">
<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#support-assistant" aria-expanded="false" aria-controls="support-assistant">Need help?</button>
<section id="support-assistant" class="collapse bg-white border rounded p-3 mt-2" style="width:320px;max-width:100%">
<h2 class="h5">Propelyze support</h2>
<p><a href="{{ url('/faq') }}">Frequently asked questions</a> · <a href="{{ url('/support') }}">Contact support</a></p>
@if(config('services.support_ai.enabled') && config('services.support_ai.key'))
<p class="small">AI answers may need checking. Messages are processed by OpenAI. Do not include passwords or payment details.</p>
<form id="support-ai-form">@csrf
<label for="support-question">Your question</label><textarea class="form-control" id="support-question" name="message" maxlength="1000" required></textarea>
<label class="small mt-2"><input type="checkbox" name="consent" value="1" required> Allow my question to be sent to OpenAI for an answer.</label>
<button class="btn btn-primary mt-2" type="submit">Ask assistant</button></form>
<p id="support-answer" class="mt-2" role="status" aria-live="polite"></p>
<script>
document.getElementById('support-ai-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const button = this.querySelector('button'); const answer = document.getElementById('support-answer');
    button.disabled = true; answer.textContent = 'Finding an answer…';
    try {
        const response = await fetch(@json(url('/support/assistant')), {method:'POST', headers:{'Accept':'application/json'}, body:new FormData(this)});
        const data = await response.json(); answer.textContent = data.message || 'Please contact support.';
    } catch (_) { answer.textContent = 'Unable to connect. Please contact support.'; }
    finally { button.disabled = false; }
});
</script>
@else<p>Use the FAQ or contact our team for help.</p>@endif
</section></aside>
