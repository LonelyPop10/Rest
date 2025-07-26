<?php

declare(strict_types=1);

namespace fly;

use pocketmine\form\Form;
use pocketmine\player\Player;

class CustomForm implements Form {

    private array $data = [];
    private \Closure $callable;

    public function __construct(callable $callable) {
        $this->callable = $callable;
    }

    public function getType(): string {
        return "custom_form";
    }

    public function getTitle(): string {
        return $this->data["title"] ?? "";
    }

    public function setTitle(string $title): void {
        $this->data["title"] = $title;
    }

    public function getContent(): array {
        return $this->data["content"] ?? [];
    }

    public function addLabel(string $text): void {
        $this->addContent(["type" => "label", "text" => $text]);
    }

    public function addInput(string $text, string $placeholder = "", string $default = null): void {
        $this->addContent(["type" => "input", "text" => $text, "placeholder" => $placeholder, "default" => $default]);
    }

    public function addToggle(string $text, bool $default = false): void {
        $this->addContent(["type" => "toggle", "text" => $text, "default" => $default]);
    }

    public function addSlider(string $text, int $min, int $max, int $step = 1, int $default = null): void {
        $this->addContent(["type" => "slider", "text" => $text, "min" => $min, "max" => $max, "step" => $step, "default" => $default]);
    }

    public function addStepSlider(string $text, array $steps, int $default = 0): void {
        $this->addContent(["type" => "step_slider", "text" => $text, "steps" => $steps, "default" => $default]);
    }

    public function addDropdown(string $text, array $options, int $default = 0): void {
        $this->addContent(["type" => "dropdown", "text" => $text, "options" => $options, "default" => $default]);
    }

    private function addContent(array $content): void {
        $this->data["content"][] = $content;
    }

    public function handleResponse(Player $player, $data): void {
        ($this->callable)($player, $data);
    }

    public function jsonSerialize(): array {
        return $this->data;
    }
}

class SimpleForm implements Form {

    private array $data = [];
    private \Closure $callable;

    public function __construct(callable $callable) {
        $this->callable = $callable;
    }

    public function getType(): string {
        return "form";
    }

    public function getTitle(): string {
        return $this->data["title"] ?? "";
    }

    public function setTitle(string $title): void {
        $this->data["title"] = $title;
    }

    public function getContent(): string {
        return $this->data["content"] ?? "";
    }

    public function setContent(string $content): void {
        $this->data["content"] = $content;
    }

    public function addButton(string $text, int $imageType = -1, string $imagePath = ""): void {
        $button = ["text" => $text];
        if ($imageType !== -1) {
            $button["image"]["type"] = $imageType === 0 ? "path" : "url";
            $button["image"]["data"] = $imagePath;
        }
        $this->data["buttons"][] = $button;
    }

    public function handleResponse(Player $player, $data): void {
        ($this->callable)($player, $data);
    }

    public function jsonSerialize(): array {
        return $this->data;
    }
}
