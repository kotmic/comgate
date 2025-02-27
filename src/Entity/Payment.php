<?php declare(strict_types = 1);

namespace Contributte\Comgate\Entity;

use Brick\Math\RoundingMode;
use Brick\Money\Money;
use Contributte\Comgate\Entity\Codes\CountryCode;
use Contributte\Comgate\Entity\Codes\LangCode;
use Contributte\Comgate\Entity\Codes\PaymentMethodCode;
use function array_merge;

class Payment extends AbstractEntity
{

	/** @var int */
	private $price;

	/** @var string ISO 4217 */
	private $curr;

	/** @var string */
	private $label;

	/** @var string */
	private $refId;

	/** @var string */
	private $email;

	/** @var string */
	private $method = PaymentMethodCode::ALL;

	/** @var string */
	private $country = CountryCode::ALL;

	/** @var string */
	private $payerId;

	/** @var string|NULL */
	private $account;

	/** @var string */
	private $phone;

	/** @var string */
	private $name;

	/** @var string ISO 639-1 */
	private $lang = LangCode::CS;

	/** @var bool */
	private $prepareOnly;

	/** @var bool */
	private $preauth;

	/** @var bool */
	private $initRecurring;

	/** @var bool */
	private $verification;

	/** @var bool */
	private $embedded;

	/** @var bool */
	private $eetReport;

	/** @var mixed[] */
	private $eetData;

	final private function __construct()
	{
	}

	public static function of(
		Money $money,
		string $label,
		string $refId,
		string $email,
		string $method = PaymentMethodCode::ALL,
		string $country = CountryCode::ALL,
		string $lang = LangCode::CS
	): self
	{
		$p = new static();
		$p->price = $money->multipliedBy(100, RoundingMode::UNNECESSARY)->getAmount()->toInt();
		$p->curr = $money->getCurrency()->getCurrencyCode();
		$p->label = $label;
		$p->refId = $refId;
		$p->email = $email;
		$p->method = $method;
		$p->country = $country;
		$p->lang = $lang;
		$p->prepareOnly = true;

		return $p;
	}

	public function getPrice(): int
	{
		return $this->price;
	}

	public function getCurr(): string
	{
		return $this->curr;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function getRefId(): string
	{
		return $this->refId;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getMethod(): string
	{
		return $this->method;
	}

	public function getCountry(): string
	{
		return $this->country;
	}

	public function getPayerId(): string
	{
		return $this->payerId;
	}

	public function setPayerId(string $payerId): void
	{
		$this->payerId = $payerId;
	}

	public function getAccount(): string
	{
		return $this->account;
	}

	public function setAccount(string $account): void
	{
		$this->account = $account;
	}

	public function getPhone(): string
	{
		return $this->phone;
	}

	public function setPhone(string $phone): void
	{
		$this->phone = $phone;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getLang(): string
	{
		return $this->lang;
	}

	public function setLang(string $lang): void
	{
		$this->lang = $lang;
	}

	public function isPrepareOnly(): bool
	{
		return $this->prepareOnly;
	}

	public function setPrepareOnly(bool $prepareOnly): void
	{
		$this->prepareOnly = $prepareOnly;
	}

	public function isPreauth(): bool
	{
		return $this->preauth;
	}

	public function setPreauth(bool $preauth): void
	{
		$this->preauth = $preauth;
	}

	public function isInitRecurring(): bool
	{
		return $this->initRecurring;
	}

	public function setInitRecurring(bool $initRecurring): void
	{
		$this->initRecurring = $initRecurring;
	}

	public function isVerification(): bool
	{
		return $this->verification;
	}

	public function setVerification(bool $verification): void
	{
		$this->verification = $verification;
	}

	public function isEmbedded(): bool
	{
		return $this->embedded;
	}

	public function setEmbedded(bool $embedded): void
	{
		$this->embedded = $embedded;
	}

	public function isEetReport(): bool
	{
		return $this->eetReport;
	}

	public function setEetReport(bool $eetReport): void
	{
		$this->eetReport = $eetReport;
	}

	/**
	 * @return mixed[]
	 */
	public function getEetData(): array
	{
		return $this->eetData;
	}

	/**
	 * @param mixed[] $eetData
	 */
	public function setEetData(array $eetData): void
	{
		$this->eetData = $eetData;
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
        $arrayWithAccount = [];

        if ($this->account !== NULL) {
            $arrayWithAccount = [
                'account' => $this->account,
            ];
        }

        $result = array_merge($arrayWithAccount, [
            'price' => $this->price,
            'curr' => $this->curr,
            'label' => $this->label,
            'refId' => $this->refId,
            'method' => $this->method,
            'email' => $this->email,
            'prepareOnly' => $this->prepareOnly ? 'true' : 'false',
            'country' => $this->country,
            'lang' => $this->lang,
            'embedded' => $this->embedded ? 'true' : 'false',
        ]);

		return $result;
	}

}
